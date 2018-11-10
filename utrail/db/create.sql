CREATE TABLE Runner (
	idRunner        INTEGER       AUTO_INCREMENT,
	firstName       VARCHAR(40)   NOT NULL,
	lastName        VARCHAR(40)   NOT NULL,
	sex             VARCHAR(1)    NOT NULL,
	category        INTEGER       NOT NULL,
	/*bibNumber       INTEGER,*/
	CONSTRAINT sexList CHECK(sex IN ('F','M')), /*problem with enum*/
	CONSTRAINT RunnerPK PRIMARY KEY (idRunner),
	INDEX(idRunner)
);

CREATE TABLE Section (
	idSection        INTEGER      AUTO_INCREMENT,
	sectionName      VARCHAR(100) NOT NULL,
	CONSTRAINT SectionPK PRIMARY KEY (idSection),
	INDEX(idSection)
);

CREATE TABLE Team (
	idTeam          INTEGER       AUTO_INCREMENT,
	teamName        VARCHAR(40),
	category        INTEGER       NOT NULL,
	CONSTRAINT TeamPK PRIMARY KEY (idTeam),
	INDEX(idTeam)
);

CREATE TABLE Race (
	idRace          INTEGER       AUTO_INCREMENT,
	raceName        VARCHAR(100)  NOT NULL,
	raceStatus      INTEGER       NOT NULL,
	distance        INTEGER       NOT NULL,
	CONSTRAINT RacePK PRIMARY KEY (idRace),
	UNIQUE(raceName),
	INDEX(idRace)
);

CREATE TABLE RanOn (
	idRanOn         INTEGER       AUTO_INCREMENT,
	idRunner        INTEGER       NOT NULL,
	idSection       INTEGER       NOT NULL,
	chrono          TIME,
	CONSTRAINT RanOnPK PRIMARY KEY (idRanOn),
	CONSTRAINT RanOnFK1 FOREIGN KEY (idRunner) REFERENCES Runner(idRunner) ON DELETE CASCADE,
	CONSTRAINT RanOnFK2 FOREIGN KEY (idSection) REFERENCES Section(idSection) ON DELETE CASCADE,
	INDEX(idRanOn)
);

CREATE TABLE BelongTo (
	idBelongTo      INTEGER       AUTO_INCREMENT,
	idRunner        INTEGER       NOT NULL,
	idTeam          INTEGER       NOT NULL,
	CONSTRAINT BelongToPK PRIMARY KEY (idBelongTo),
	CONSTRAINT BelongToFK1 FOREIGN KEY (idRunner) REFERENCES Runner(idRunner) ON DELETE CASCADE,
	CONSTRAINT BelongToFK2 FOREIGN KEY (idTeam) REFERENCES Team(idTeam) ON DELETE CASCADE,
	INDEX(idBelongTo)
);

CREATE TABLE Compose (
	idCompose       INTEGER       AUTO_INCREMENT,
	idRace          INTEGER       NOT NULL,
	idSection       INTEGER       NOT NULL,
	timeLimit       TIME,
	isChrono        INTEGER       NOT NULL        DEFAULT 0,
	CONSTRAINT ComposePK PRIMARY KEY (idCompose),
	CONSTRAINT ComposeFK1 FOREIGN KEY (idRace) REFERENCES Race(idRace) ON DELETE CASCADE,
	CONSTRAINT ComposeFK2 FOREIGN KEY (idSection) REFERENCES Section(idSection) ON DELETE CASCADE,
	INDEX(idCompose)
);

CREATE TABLE Participate (
	idParticipate   INTEGER       AUTO_INCREMENT,
	idTeam          INTEGER       NOT NULL,
	idRace          INTEGER       NOT NULL,
	chrono          TIME,
	CONSTRAINT ParticipatePK PRIMARY KEY (idParticipate),
	CONSTRAINT ParticipateFK1 FOREIGN KEY (idTeam) REFERENCES Team(idTeam) ON DELETE CASCADE,
	CONSTRAINT ParticipateFK2 FOREIGN KEY (idRace) REFERENCES Race(idRace) ON DELETE CASCADE,
	INDEX(idParticipate)
);

/*
DELIMITER |

CREATE TRIGGER afterUpdateRanOn AFTER UPDATE
ON RanOn FOR EACH ROW
BEGIN
	UPDATE Participate
	SET chrono = SELECT MAX(chrono)
		SELECT
	)
	WHERE idTeam = NEW.
END |

*/

CREATE TABLE Visitor (
	idVisitor       INTEGER       AUTO_INCREMENT,
	idSession       VARCHAR(100)  NOT NULL,
	IP              VARCHAR(20)   NOT NULL,
	browser         VARCHAR(500)  NOT NULL,
	authenticated   INTEGER       NOT NULL,
	CONSTRAINT VisitorPK PRIMARY KEY (idVisitor),
	INDEX(idVisitor)
);

CREATE TABLE ReceivedFile (
	idReceivedFile  INTEGER       AUTO_INCREMENT,
	idRace          INTEGER       NOT NULL,
	receptionDate   DATETIME      NOT NULL,
	CONSTRAINT ReceivedFilePK PRIMARY KEY (idReceivedFile),
	CONSTRAINT ReceivedFileFK FOREIGN KEY (idRace) REFERENCES Race(idRace) ON DELETE CASCADE,
	INDEX(idReceivedFile)
);

CREATE TABLE DumpedCache (
	idDumpedCache   INTEGER       AUTO_INCREMENT,
	idRace          INTEGER       NOT NULL,
	dumpDate        DATETIME      NOT NULL,
	dumpSize        BIGINT        NOT NULL,
	CONSTRAINT DumpedCachePK PRIMARY KEY (idDumpedCache),
	CONSTRAINT DumpedCacheFK FOREIGN KEY (idRace) REFERENCES Race(idRace) ON DELETE CASCADE,
	INDEX(idDumpedCache)
);